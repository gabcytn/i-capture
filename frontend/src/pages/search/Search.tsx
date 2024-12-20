import { useSearchParams } from "react-router";
import styles from "./Search.module.css";
import { useEffect, useState } from "react";
import SideNav from "../../components/SideNav/SideNav";

type User = {
  id: string;
  username: string;
  profilePic: string;
};

function Search() {
  const [searchParams] = useSearchParams();
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  const [users, setUsers] = useState<User[]>([]);
  useEffect(() => {
    const searchUsername = searchParams.get("username");
    const fetchUsers = async () => {
      try {
        const res = await fetch(`${SERVER_URL}/search/${searchUsername}`, {
          credentials: "include",
        });
        switch (res.status) {
          case 404:
            setUsers([]);
            break;
          case 403:
            alert("Session has expired...Logging you out");
            sessionStorage.clear();
            location.reload();
            break;
          case 200: {
            const data = await res.json();
            setUsers(data);
            break;
          }
          default:
            throw new Error(`Error status code of ${res.status}`);
        }
      } catch (e) {
        if (e instanceof Error) {
          console.error("Error fetching users");
          console.error(e.message);
        }
      }
    };
    fetchUsers();
  }, [searchParams, SERVER_URL]);
  return (
    <>
      <SideNav />
      <div className="container">
        <div className="row">
          {users.length === 0 ? (
            <div className={styles.noUserDiv}>
              <h2 className={styles.noUserFound}>No User Found</h2>
            </div>
          ) : (
            <>
              <h2 className="text-center">Users</h2>
              {users.map((user) => {
                return (
                  <div className="col-12 mt-3">
                    <a
                      href={`${location.origin}/${user.username}`}
                      className="d-flex align-items-center text-decoration-none text-dark"
                    >
                      <img
                        src={user.profilePic}
                        alt=""
                        className={styles.searchImage}
                      />
                      <p className="ms-3">
                        @<strong>{user.username}</strong>
                      </p>
                    </a>
                  </div>
                );
              })}
            </>
          )}
        </div>
      </div>
    </>
  );
}

export default Search;
