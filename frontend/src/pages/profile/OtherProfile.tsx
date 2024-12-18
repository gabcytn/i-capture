import Button from "../../components/Button";
import SideNav from "../../components/SideNav/SideNav";
import ProfilePostsLayout from "../../layout/ProfilePostsLayout";
import { useParams } from "react-router";
import { useState, useEffect, CSSProperties } from "react";
type ProfileProps = {
  userDetails: {
    username: string;
    profilePic: string;
    followers: number;
    followings: number;
  };
};
function OtherProfile({ userDetails }: ProfileProps) {
  const profileName = useParams().segment!;
  const [postsCount, setPostsCount] = useState<number>(0);
  useEffect(() => {
    document.title = profileName;
  }, [profileName]);

  return (
    <>
      <SideNav />
      <div className="container mt-5">
        <div className="row">
          <div className="col-4">
            <div className="cursor-pointer" role="button">
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
                <p style={usernameStyles}>{`@${profileName}`}</p>
                <Button
                  title="Follow"
                  className="btn btn-primary"
                  type="button"
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
export default OtherProfile;
