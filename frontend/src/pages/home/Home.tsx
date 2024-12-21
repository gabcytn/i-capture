import { Tab, Tabs, TabList, TabPanel } from "react-tabs";
import SideNav from "../../components/SideNav/SideNav";
import styles from "./Home.module.css";
import PostFeed from "./tabs/PostFeed.tsx";
import { useState } from "react";
type Post = {
  postId: number;
  photoUrl: string;
  profilePic: string;
  postOwner: string;
};
function Home() {
  const [forYouPosts, setForYouPosts] = useState<Post[] | null>(null);
  const [followingPosts, setFollowingPosts] = useState<Post[] | null>(null);
  const [likedPosts, setLikedPosts] = useState<Post[] | null>(null);
  return (
    <>
      <SideNav />
      <Tabs className={"container"} selectedTabClassName={styles.activeTab}>
        <TabList className={styles.tabList}>
          <Tab className={styles.tabItem}>For you</Tab>
          <Tab className={styles.tabItem}>Following</Tab>
          <Tab className={styles.tabItem}>Likes</Tab>
        </TabList>

        <TabPanel>
          <PostFeed
            postProp={forYouPosts}
            setPostProp={setForYouPosts}
            feedType="for-you"
          />
        </TabPanel>
        <TabPanel>
          <PostFeed
            postProp={followingPosts}
            setPostProp={setFollowingPosts}
            feedType="followings"
          />
        </TabPanel>
        <TabPanel>
          <PostFeed
            postProp={likedPosts}
            setPostProp={setLikedPosts}
            feedType="liked"
          />
        </TabPanel>
      </Tabs>
    </>
  );
}

export default Home;
