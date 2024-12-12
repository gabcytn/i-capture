import { useParams } from "react-router"
import SideNav from "../components/SideNav/SideNav"
function Profile() {
  const profileName = useParams().segment;
  return (
    <>
      <SideNav />
      <div className="container">
        <h3>{profileName}</h3>
      </div>
    </>
  )
}

export default Profile
