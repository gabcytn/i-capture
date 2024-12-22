import { Tab, Tabs, TabList, TabPanel } from "react-tabs";
import SideNav from "../../components/SideNav/SideNav";
import styles from "./Home.module.css";
import PostFeed from "./tabs/PostFeed.tsx";
import { useState } from "react";
function Home() {
  const [likeButtons, setLikeButtons] = useState<Map<number, boolean>>(
    new Map(),
  );
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
            feedType="for-you"
            likeButtons={likeButtons}
            setLikeButtons={setLikeButtons}
          />
        </TabPanel>
        <TabPanel>
          <PostFeed
            feedType="followings"
            likeButtons={likeButtons}
            setLikeButtons={setLikeButtons}
          />
        </TabPanel>
        <TabPanel>
          <PostFeed
            feedType="liked"
            likeButtons={likeButtons}
            setLikeButtons={setLikeButtons}
          />
        </TabPanel>
      </Tabs>
    </>
  );
}

export default Home;
