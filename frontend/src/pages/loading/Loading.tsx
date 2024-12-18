import styles from "./Loading.module.css";
function Loading() {
  return (
    <div className={styles.wrapper}>
      <div className={styles.loader}></div>
      <div className={styles.loadingText}>Loading...</div>
    </div>
  );
}

export default Loading;
