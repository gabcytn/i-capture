import SideNav from "../components/SideNav/SideNav";

function App() {
  const url = import.meta.env.VITE_SERVER_URL;

  const sendRequest = async () => {
    try {
      const res = await fetch(`${url}/session-id`, {
        method: "GET",
        credentials: "include",
      });
      const data = await res.text();
      alert(`${res.status}: ${data}`);
    } catch (e) {
      if (e instanceof Error) alert(`Error in test request: ${e.message}`);
    }
  };

  return (
    <>
      <SideNav />
      <div className="container">
        <p>App</p>
        <button onClick={sendRequest} className="btn btn-warning">
          Test request
        </button>
      </div>
    </>
  );
}

export default App;
