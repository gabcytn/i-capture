import { useState } from "react";
import SideNav from "../../components/SideNav/SideNav";
import { CSSProperties } from "react";
import Button from "../../components/Button";
import ProfilePostsLayout from "../../layout/ProfilePostsLayout";
import DialogBox from "../../components/DialogBox";
import FormInput from "../../components/FormInput";
type ProfileProps = {
  userDetails: {
    username: string;
    profilePic: string;
    followers: number;
    followings: number;
  };
};
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
function Profile({ userDetails }: ProfileProps) {
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  document.title = userDetails.username;
  const [postsCount, setPostsCount] = useState<number>(0);
  const [oldPasswordValue, setOldPasswordValue] = useState<string>("");
  const [newPasswordValue, setNewPasswordValue] = useState<string>("");
  const [newProfileValue, setNewProfileValue] = useState<File | null>(null);
  const [isChangePasswordDialogOpen, setIsChangePasswordDialogOpen] =
    useState<boolean>(false);
  const [isChangeProfileDialogOpen, setIsChangeProfileDialogOpen] =
    useState<boolean>(false);
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
                setIsChangeProfileDialogOpen(true);
              }}
            >
              <img
                src={userDetails.profilePic}
                alt="User's profile picture"
                style={profileImgStyles}
              />
            </div>
          </div>
          <div className="col-8">
            <div>
              <div className="d-flex gap-3">
                <p style={usernameStyles}>{`@${userDetails.username}`}</p>
                <Button
                  title="Change password"
                  className="btn btn-secondary"
                  type="button"
                  handleClick={() => {
                    setIsChangePasswordDialogOpen(true);
                  }}
                />
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
        <Button className="mt-3 btn btn-primary" title="Submit" type="button" />
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

const usernameStyles: CSSProperties = {
  alignSelf: "center",
  margin: "0",
  fontWeight: "600",
};

const profileImgStyles: CSSProperties = {
  width: "10rem",
  height: "10rem",
  borderRadius: "100%",
  marginRight: "0.5rem",
};
export default Profile;
