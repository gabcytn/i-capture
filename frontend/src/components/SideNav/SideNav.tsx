import { useNavigate } from "react-router";
import styles from "./SideNav.module.css"
import IonIcon from "@reacticons/ionicons";

function SideNav() {
  const navigate = useNavigate();
  const url = import.meta.env.VITE_SERVER_URL;

  const handleLogout = async () => {
    try {
      const res = await fetch(`${url}/logout`, {
        method: "POST",
        credentials: "include",
      });

      if (res.status === 204) {
        localStorage.clear();
        navigate("/login");
      }

    } catch (e: unknown) {
      if (e instanceof Error) alert(e.message);
    }
  }
  return (
    <div className={styles.sideNav}>
      <h1 className={styles.sideNavHeading}>iCapture</h1>
      <ul className={styles.sideNavList}>
        <li className={styles.sideNavItem}>
          <IonIcon style={iconStyle} name="home" />
          <a className={styles.sideNavLink} href="#">Home</a>
        </li>
        <li className={styles.sideNavItem}>
          <IonIcon style={iconStyle} name="search" />
          <a className={styles.sideNavLink} href="#">Search</a>
        </li>
        <li className={styles.sideNavItem}>
          <IonIcon style={iconStyle} name="add-circle" />
          <a className={styles.sideNavLink} href="#">Create</a>
        </li>
        <li className={styles.sideNavItem}>
          <img src="#" alt="profile pic" className={styles.sideNavProfile} />
          <a className={styles.sideNavLink} href="#">Profile</a>
        </li>
      </ul>
      <div className={styles.logoutForm}>
        <button onClick={handleLogout} className="btn btn-danger">Logout</button>
      </div>
    </div>
  )
}

const iconStyle = {
  display: "flex",
  fontSize: "1.5rem",
}

export default SideNav
