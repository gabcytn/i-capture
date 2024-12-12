import { Navigate, Outlet } from "react-router"

function PublicRoute() {
  if (!localStorage.getItem("isLoggedIn"))
    return <Outlet />

  return <Navigate to={"/"} replace />
}

export default PublicRoute;
