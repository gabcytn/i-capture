import { useParams } from "react-router";
import OtherProfile from "../pages/profile/OtherProfile";
import OwnProfile from "../pages/profile/OwnProfile";
import { useEffect, useState } from "react";
import NotFound from "../pages/NotFound";
import Loading from "../pages/loading/Loading";

type ProfileProps = {
  userDetails: {
    username: string;
    profilePic: string;
    followers: number;
    followings: number;
  };
};

function ProfileRoute() {
  const [isNotFound, setIsNotFound] = useState<boolean | null>(null);
  const [userDetails, setUserDetails] = useState<ProfileProps["userDetails"]>();
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
            setUserDetails(data);
            setIsNotFound(false);
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

  if (isNotFound === null) {
    return <Loading />;
  } else if (isNotFound) {
    return <NotFound />;
  } else if (segment === sessionStorage.getItem("username")) {
    return userDetails ? <OwnProfile userDetails={userDetails} /> : null;
  } else {
    return userDetails ? <OtherProfile userDetails={userDetails} /> : null;
  }
}

export default ProfileRoute;
