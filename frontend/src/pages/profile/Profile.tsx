import styles from "./Profile.module.css";
import { useState, useEffect } from "react";
import SideNav from "../../components/SideNav/SideNav";
import Button from "../../components/Button";
import ProfilePostsLayout from "../../layout/ProfilePostsLayout";
import DialogBox from "../../components/DialogBox";
import FormInput from "../../components/FormInput";
import { useParams } from "react-router";
import NotFound from "../NotFound";
import Loading from "../loading/Loading";

async function handleChangeProfilePic(serverUrl: string, file: File | null) {
  if (file === null) {
    alert("File can't be null");
    return;
  }
  const formData = new FormData();
  formData.append("id", sessionStorage.getItem("id")!);
  formData.append("file", file);
  try {
    const res = await fetch(`${serverUrl}/profile-image`, {
      method: "POST",
      body: formData,
      credentials: "include",
    });
    if (res.status === 202) {
      location.reload();
      return;
    }

    throw new Error(`Error status code of ${res.status}`);
  } catch (e: unknown) {
    if (e instanceof Error) {
      console.error("Error uploading image");
      console.error(e.message);
    }
  }
}

async function handlePasswordChange(
  serverUrl: string,
  oldPassword: string,
  newPassword: string,
  setIsDialogOpen: (value: boolean) => void,
) {
  if (oldPassword === "" || newPassword === "") {
    alert("Fields can't be blank");
    return;
  }
  try {
    const res = await fetch(`${serverUrl}/change-password`, {
      method: "PUT",
      body: JSON.stringify({
        id: sessionStorage.getItem("id"),
        oldPassword: oldPassword,
        newPassword: newPassword,
      }),
      credentials: "include",
      headers: {
        "Content-Type": "application/json",
      },
    });
    switch (res.status) {
      case 400:
        alert("Incorrect password");
        return;
      case 202:
        setIsDialogOpen(false);
        alert("Successfully changed password");
        return;
      default:
        throw new Error(`Error status code of ${res.status}`);
    }
  } catch (e: unknown) {
    if (e instanceof Error) {
      console.error("Error updating password");
      console.error(e.message);
    }
  }
}

type UserDetails = {
  username: string;
  profilePic: string;
  followers: number;
  followings: number;
  isOwnProfile: boolean;
};
function Profile() {
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  const [userDetails, setUserDetails] = useState<UserDetails | null>(null);
  const [isNotFound, setIsNotFound] = useState<boolean>(false);
  const [isOwnProfile, setIsOwnProfile] = useState<boolean | null>(null);
  const [isFollowed, setIsFollowed] = useState<boolean | null>(null);
  const [postsCount, setPostsCount] = useState<number>(0);
  const [oldPasswordValue, setOldPasswordValue] = useState<string>("");
  const [newPasswordValue, setNewPasswordValue] = useState<string>("");
  const [newProfileValue, setNewProfileValue] = useState<File | null>(null);
  const [isChangePasswordDialogOpen, setIsChangePasswordDialogOpen] =
    useState<boolean>(false);
  const [isChangeProfileDialogOpen, setIsChangeProfileDialogOpen] =
    useState<boolean>(false);
  const segment = useParams().segment;
  useEffect(() => {
    const fetchProfileData = async () => {
      const SERVER_URL = import.meta.env.VITE_SERVER_URL;
      try {
        const res = await fetch(`${SERVER_URL}/${segment}`, {
          method: "GET",
          credentials: "include",
        });

        switch (res.status) {
          case 404:
            setIsNotFound(true);
            break;
          case 200: {
            const data = await res.json();
            console.log(data);
            setUserDetails(data);
            setIsNotFound(false);
            setIsOwnProfile(data.isOwnProfile);
            setIsFollowed(data.isFollowing);
            break;
          }
          default:
            throw new Error(`Status code of ${res.status}`);
        }
      } catch (e: unknown) {
        if (e instanceof Error) {
          console.error("Error fetching user data");
          console.error(e.message);
        }
      }
    };

    fetchProfileData();
  }, [segment]);
  if (isNotFound) return <NotFound />;
  else if (userDetails === null) return <Loading />;
  return (
    <>
      <SideNav />
      <div className="container mt-5">
        <div className="row">
          <div className="col-4">
            <div
              className="cursor-pointer"
              role="button"
              onClick={() => {
                if (isOwnProfile) {
                  setIsChangeProfileDialogOpen(true);
                }
              }}
            >
              <img
                src={userDetails.profilePic}
                alt="User's profile picture"
                className={styles.profileImage}
              />
            </div>
          </div>
          <div className="col-8">
            <div>
              <div className="d-flex gap-3">
                <p className={styles.username}>{`@${userDetails.username}`}</p>
                {isOwnProfile ? (
                  <Button
                    title="Change password"
                    className="btn btn-secondary"
                    type="button"
                    handleClick={() => {
                      setIsChangePasswordDialogOpen(true);
                    }}
                  />
                ) : (
                  <Button
                    title={isFollowed ? "Unfollow" : "Follow"}
                    className={
                      isFollowed ? "btn btn-secondary" : "btn btn-primary"
                    }
                    type="button"
                    handleClick={() => {
                      setIsFollowed(!isFollowed);
                    }}
                  />
                )}
              </div>

              <div className="d-flex gap-5 mt-3">
                <p>{postsCount} posts</p>
                <p id="followers-list" role="button">
                  {userDetails.followers} followers
                </p>
                <p id="followings-list" role="button">
                  {userDetails.followings} following
                </p>
              </div>
            </div>
          </div>
        </div>
        <hr />
        <ProfilePostsLayout setPostsCount={setPostsCount} />
      </div>
      <DialogBox title="Update Password" isOpen={isChangePasswordDialogOpen}>
        <FormInput
          type="password"
          onChange={(e) => {
            setOldPasswordValue(e.target.value);
          }}
          value={oldPasswordValue}
          className="mt-3"
          placeholder="Old password"
        />
        <FormInput
          type="password"
          onChange={(e) => {
            setNewPasswordValue(e.target.value);
          }}
          value={newPasswordValue}
          className="mt-2"
          placeholder="New password"
        />
        <Button
          className="mt-3 btn btn-primary"
          title="Submit"
          type="button"
          handleClick={() => {
            handlePasswordChange(
              SERVER_URL,
              oldPasswordValue,
              newPasswordValue,
              setIsChangePasswordDialogOpen,
            );
            setOldPasswordValue("");
            setNewPasswordValue("");
          }}
        />
        <Button
          className="mt-3 ms-2 btn btn-danger"
          title="Close"
          type="button"
          handleClick={() => {
            setIsChangePasswordDialogOpen(false);
          }}
        />
      </DialogBox>
      <DialogBox title="Update Profile" isOpen={isChangeProfileDialogOpen}>
        <FormInput
          type="file"
          onChange={(e) => {
            if (e.target.files && e.target.files.length !== 0) {
              setNewProfileValue(e.target.files[0]);
            }
          }}
        />
        <Button
          className="mt-3 btn btn-primary"
          title="Submit"
          type="button"
          handleClick={() => {
            handleChangeProfilePic(SERVER_URL, newProfileValue);
          }}
        />
        <Button
          className="mt-3 ms-2 btn btn-danger"
          title="Close"
          type="button"
          handleClick={() => {
            setIsChangeProfileDialogOpen(false);
          }}
        />
      </DialogBox>
    </>
  );
}

export default Profile;
