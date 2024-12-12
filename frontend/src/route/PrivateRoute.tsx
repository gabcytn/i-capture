import { Navigate, Outlet } from "react-router"

function PrivateRoute() {
  if (localStorage.getItem("isLoggedIn"))
    return <Outlet />

  return <Navigate to={"/login"} replace />
}

export default PrivateRoute
