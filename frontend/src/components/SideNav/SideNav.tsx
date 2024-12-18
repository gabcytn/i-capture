import { CSSProperties, useState } from "react";
import { useNavigate } from "react-router";
import styles from "./SideNav.module.css";
import IonIcon from "@reacticons/ionicons";
import DialogBox from "../DialogBox";
import Button from "../Button";
import FormInput from "../FormInput";

async function handleCreatePost(
  event: React.FormEvent<HTMLFormElement>,
  serverUrl: string,
  file: File | null,
) {
  event.preventDefault();
  if (file === null) {
    alert("Post can't be blank");
    return;
  }
  const formData = new FormData();
  formData.append("id", sessionStorage.getItem("id")!);
  formData.append("file", file);
  try {
    const res = await fetch(`${serverUrl}/post/create`, {
      method: "POST",
      body: formData,
      credentials: "include",
    });

    if (res.status === 201) {
      alert("Post created");
      location.reload();
      return;
    }
    throw new Error(`Error status code of: ${res.status}`);
  } catch (e: unknown) {
    if (e instanceof Error) {
      console.error("Error creating post");
      console.error(e.message);
    }
  }
}

function SideNav() {
  const [isCreateDialogOpen, setIsCreateDialogOpen] = useState<boolean>(false);
  const [isSearchDialogOpen, setIsSearchDialogOpen] = useState<boolean>(false);
  const [searchValue, setSearchValue] = useState<string>("");
  const [file, setFile] = useState<File | null>(null);

  const username = sessionStorage.getItem("username")!;
  const navigate = useNavigate();
  const url = import.meta.env.VITE_SERVER_URL;
  const proflePic: string = sessionStorage.getItem("profilePic")!;

  const openSearchDialog = () => {
    setIsSearchDialogOpen(true);
  };

  const closeSearchDialog = () => {
    setIsSearchDialogOpen(false);
  };

  const closeCreateDialog = () => {
    setIsCreateDialogOpen(false);
  };

  const openCreateDialog = () => {
    setIsCreateDialogOpen(true);
  };

  const handleLogout = async () => {
    try {
      const res = await fetch(`${url}/logout`, {
        method: "POST",
        credentials: "include",
      });

      if (res.status === 204) {
        sessionStorage.clear();
        navigate("/login");
      }
    } catch (e: unknown) {
      if (e instanceof Error) alert(e.message);
    }
  };
  return (
    <>
      <div className={styles.sideNav}>
        <h1 className={styles.sideNavHeading}>iCapture</h1>
        <ul className={styles.sideNavList}>
          <li className={styles.sideNavItem}>
            <IonIcon style={iconStyle} name="home" />
            <a className={styles.sideNavLink} href="/">
              Home
            </a>
          </li>
          <li className={styles.sideNavItem} onClick={openSearchDialog}>
            <IonIcon style={iconStyle} name="search" />
            <a className={styles.sideNavLink} href="#">
              Search
            </a>
          </li>
          <li className={styles.sideNavItem} onClick={openCreateDialog}>
            <IonIcon style={iconStyle} name="add-circle" />
            <a className={styles.sideNavLink} href="#">
              Create
            </a>
          </li>
          <li className={styles.sideNavItem}>
            <img
              src={proflePic}
              alt="profile pic"
              className={styles.sideNavProfile}
            />
            <a
              className={styles.sideNavLink}
              href={`${window.location.origin}/${username}`}
            >
              Profile
            </a>
          </li>
        </ul>
        <div className={styles.logoutForm}>
          <Button
            title="Logout"
            className="btn btn-danger"
            handleClick={handleLogout}
            type="button"
          />
        </div>
      </div>
      <DialogBox isOpen={isSearchDialogOpen} title="Search User">
        <FormInput
          type="text"
          placeholder="Search"
          onChange={(e: React.ChangeEvent<HTMLInputElement>) => {
            setSearchValue(e.target.value);
          }}
          value={searchValue}
        />
        <div className="d-flex mt-3">
          <Button
            title="Submit"
            type="button"
            className="btn btn-primary me-2"
          />
          <Button
            title="Close"
            className="btn btn-danger"
            type="button"
            handleClick={closeSearchDialog}
          />
        </div>
      </DialogBox>
      <DialogBox isOpen={isCreateDialogOpen} title="Create">
        <FormInput
          type="file"
          onChange={(e) => {
            if (e.target.files && e.target.files.length > 0)
              setFile(e.target.files[0]);
          }}
        />
        <form
          className="d-flex mt-3"
          onSubmit={(event) => {
            handleCreatePost(event, url, file);
          }}
        >
          <Button
            title="Submit"
            type="submit"
            className="btn btn-primary me-2"
          />
          <Button
            title="Close"
            className="btn btn-danger"
            type="button"
            handleClick={closeCreateDialog}
          />
        </form>
      </DialogBox>
    </>
  );
}

const iconStyle: CSSProperties = {
  display: "flex",
  fontSize: "1.5rem",
};

export default SideNav;
