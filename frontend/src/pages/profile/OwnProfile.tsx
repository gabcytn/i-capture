import { useState } from "react";
import { useParams } from "react-router";
import SideNav from "../../components/SideNav/SideNav";
import { CSSProperties, useEffect } from "react";
import Button from "../../components/Button";
import ProfilePostsLayout from "../../layout/ProfilePostsLayout";
import DialogBox from "../../components/DialogBox";
import FormInput from "../../components/FormInput";
function Profile() {
  const [oldPasswordValue, setOldPasswordValue] = useState<string>("");
  const [newPasswordValue, setNewPasswordValue] = useState<string>("");
  const [isChangePasswordDialogOpen, setIsChangePasswordDialogOpen] =
    useState<boolean>(false);
  const [isChangeProfileDialogOpen, setIsChangeProfileDialogOpen] =
    useState<boolean>(false);
  const profileName = useParams().segment!;
  const profilePic = sessionStorage.getItem("profilePic")!;
  useEffect(() => {
    document.title = profileName;
  }, [profileName]);
  return (
    <>
      <SideNav />
      <div className="container mt-5">
        <div className="row">
          <div className="col-4">
            <div className="cursor-pointer">
              <img
                src={profilePic}
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
                  title="Change password"
                  className="btn btn-secondary"
                  type="button"
                  handleClick={() => {
                    setIsChangePasswordDialogOpen(true);
                  }}
                />
              </div>

              <div className="d-flex gap-5 mt-3">
                <p>2 posts</p>
                <p id="followers-list" role="button">
                  2 followers
                </p>
                <p id="followings-list" role="button">
                  2 following
                </p>
              </div>
            </div>
          </div>
        </div>
        <hr />
        <ProfilePostsLayout />
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
