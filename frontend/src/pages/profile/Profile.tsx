import styles from "./Profile.module.css";
import { useState, useEffect } from "react";
import SideNav from "../../components/SideNav/SideNav";
import Button from "../../components/Button";
import ProfilePostsLayout from "../../layout/ProfilePostsLayout";
import FollowDialog from "./dialogs/follow/FollowDialog";
import UpdatePassword from "./dialogs/UpdatePassword";
import UpdateProfile from "./dialogs/UpdateProfile";
import { useParams } from "react-router";
import NotFound from "../NotFound";
import Loading from "../loading/Loading";

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
  const [isDialogFollowers, setIsDialogFollowers] = useState<boolean | null>(
    null,
  );
  const [postsCount, setPostsCount] = useState<number>(0);
  const [isChangePasswordDialogOpen, setIsChangePasswordDialogOpen] =
    useState<boolean>(false);
  const [isChangeProfileDialogOpen, setIsChangeProfileDialogOpen] =
    useState<boolean>(false);
  const [isFollowDialogOpen, setIsFollowDialogOpen] = useState<boolean>(false);
  const segment = useParams().segment;
  useEffect(() => {
    const fetchProfileData = async () => {
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
            sessionStorage.setItem("profilePic", data.profilePic);
            setUserDetails(data);
            setIsNotFound(false);
            setIsOwnProfile(data.isOwnProfile);
            setIsFollowed(data.isFollowing);
            break;
          }
          case 403:
            alert("Your session has expired...Logging you out");
            sessionStorage.clear();
            location.reload();
            return;
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
  }, [segment, SERVER_URL]);
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
                <p
                  role="button"
                  onClick={() => {
                    if (isOwnProfile) {
                      setIsDialogFollowers(true);
                      setIsFollowDialogOpen(true);
                    }
                  }}
                >
                  {userDetails.followers} followers
                </p>
                <p
                  role="button"
                  onClick={() => {
                    if (isOwnProfile) {
                      setIsDialogFollowers(false);
                      setIsFollowDialogOpen(true);
                    }
                  }}
                >
                  {userDetails.followings} following
                </p>
              </div>
            </div>
          </div>
        </div>
        <hr />
        <ProfilePostsLayout setPostsCount={setPostsCount} />
      </div>
      <FollowDialog
        isDialogOpen={isFollowDialogOpen}
        setIsDialogOpen={setIsFollowDialogOpen}
        isFollowers={isDialogFollowers}
      />
      <UpdatePassword
        isDialogOpen={isChangePasswordDialogOpen}
        setIsDialogOpen={setIsChangePasswordDialogOpen}
      />
      <UpdateProfile
        isDialogOpen={isChangeProfileDialogOpen}
        setIsDialogOpen={setIsChangeProfileDialogOpen}
      />
    </>
  );
}

export default Profile;
