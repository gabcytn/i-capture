import { BrowserRouter, Route, Routes } from "react-router";
import { createRoot } from "react-dom/client";
import Login from "./pages/auth/Login.tsx";
import Register from "./pages/auth/Register.tsx";
import NotFound from "./pages/NotFound.tsx";
import PrivateRoute from "./route/PrivateRoute.tsx";
import PublicRoute from "./route/PublicRoute.tsx";
import Post from "./pages/post/Post.tsx";
import Profile from "./pages/profile/Profile.tsx";
import Search from "./pages/search/Search.tsx";
import Home from "./pages/home/Home.tsx";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";

const queryClient = new QueryClient();

const Main = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route element={<PrivateRoute />}>
          <Route path="/" element={<Home />} />
          <Route path="/home" element={<Home />} />
          <Route path="/:segment" element={<Profile />} />
          <Route path="/post/:segment" element={<Post />} />
          <Route path="*" element={<NotFound />} />
          <Route path="/search" element={<Search />} />
        </Route>
        <Route element={<PublicRoute />}>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
};

export default Main;

createRoot(document.getElementById("root")!).render(
  <QueryClientProvider client={queryClient}>
    <Main />
  </QueryClientProvider>,
);
