import { useNavigate } from "react-router";
function App() {
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

  const sendRequest = async () => {
    try {
      const res = await fetch(`${url}/session-id`, {
        method: "GET",
        credentials: "include",
      });
      const data = await res.text();
      alert(`${res.status}: ${data}`);
    } catch (e) {
      if (e instanceof Error)
        alert(`Error in test request: ${e.message}`);
    }
  }

  return (
    <div>
      <p>App</p>
      <button onClick={handleLogout} className="btn btn-danger">Logout</button>
      <button onClick={sendRequest} className="btn btn-warning">Test request</button>
    </div>
  )
}

export default App
