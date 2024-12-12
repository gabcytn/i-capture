import { Navigate, Outlet } from "react-router"

function PrivateRoute() {
  if (sessionStorage.getItem("isLoggedIn"))
    return <Outlet />

  return <Navigate to={"/login"} replace />
}

export default PrivateRoute
