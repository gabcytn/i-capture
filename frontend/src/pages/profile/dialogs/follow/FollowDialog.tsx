import { useEffect, useState } from "react";
import styles from "./FollowDialog.module.css";
import DialogBox from "../../../../components/DialogBox";
import Button from "../../../../components/Button";

async function fetchFollows(endpoint: string, list: Follows[]) {
  if (list.length !== 0) return;
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  try {
    const res = await fetch(`${SERVER_URL}/${endpoint}`, {
      method: "GET",
      credentials: "include",
    });
    if (!res.ok) {
      throw new Error(`Error status code of: ${res.status}`);
    }
    const data = await res.json();
    return data;
  } catch (e: unknown) {
    if (e instanceof Error) {
      console.error(e.message);
      console.error("Error fetching followers/followings list");
    }
  }
}
type Follows = {
  id: string;
  profilePic: string;
  username: string;
};

type FollowDialogProps = {
  isDialogOpen: boolean;
  setIsDialogOpen: (val: boolean) => void;
  isFollowers: boolean | null;
};

function FollowDialog({
  isDialogOpen,
  setIsDialogOpen,
  isFollowers,
}: FollowDialogProps) {
  const [listToDisplay, setListToDisplay] = useState<Follows[] | null>(null);
  const [followersList, setFollowersList] = useState<Follows[]>([]);
  const [followingsList, setFollowingsList] = useState<Follows[]>([]);

  useEffect(() => {
    if (!isDialogOpen) return;
    const doSideEffect = async () => {
      if (isFollowers) {
        const data = await fetchFollows("followers", followersList);
        if (data === undefined) return;
        setListToDisplay(data);
        setFollowersList(data);
        return;
      } else if (!isFollowers) {
        const data = await fetchFollows("followings", followingsList);
        if (data === undefined) return;
        setListToDisplay(data);
        setFollowingsList(data);
      }
    };
    doSideEffect();
  }, [isDialogOpen]);

  if (!isDialogOpen || !listToDisplay) return null;

  return (
    <DialogBox isOpen={true} title={isFollowers ? "Followers" : "Following"}>
      {listToDisplay.map((item) => {
        return (
          <div key={item.id} className={styles.followsItem}>
            <img
              src={item.profilePic}
              alt=""
              className={styles.followsItemImage}
            />
            <a
              href={`${location.origin}/${item.username}`}
              className={styles.followsItemAnchor}
            >
              @{item.username}
            </a>
          </div>
        );
      })}
      <Button
        title="Close"
        className="btn btn-danger mt-3"
        type="button"
        handleClick={() => {
          setIsDialogOpen(false);
        }}
      />
    </DialogBox>
  );
}

export default FollowDialog;
