import { Navigate, Outlet } from "react-router"

function PublicRoute() {
  if (!sessionStorage.getItem("isLoggedIn"))
    return <Outlet />

  return <Navigate to={"/"} replace />
}

export default PublicRoute;
