import { useParams } from "react-router";
import OtherProfile from "../pages/profile/OtherProfile";
import OwnProfile from "../pages/profile/OwnProfile";

function ProfileRoute() {
  if (useParams().segment === sessionStorage.getItem("username"))
    return <OwnProfile />;

  return <OtherProfile />;
}

export default ProfileRoute;
