import { useState } from 'react';
import { useNavigate } from "react-router"
import AuthLayout from "../../layout/AuthLayout"
import Button from "../../components/Button"
import AuthTextInput from "../../components/AuthTextInput"

function Login() {
  const [username, setUsername] = useState<string>("")
  const [password, setPassword] = useState<string>("")
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  const navigate = useNavigate();

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    try {
      const res = await fetch(`${SERVER_URL}/login`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: username,
          password: password,
        }),
        credentials: "include",
      })
      if (!res.ok)
        throw new Error(`Error status code of: ${res.status}`);

      localStorage.setItem("isLoggedIn", "true");
      navigate("/");

    } catch (error: unknown) {
      if (error instanceof Error) alert(error.message);
      else console.error("Unknown error on login")
    }
  }

  return (
    <AuthLayout subText="Don't have an account? " subTextAnchor="Sign up" subTextHref="/register" onSubmit={handleSubmit}>
      <AuthTextInput value={username} onChange={setUsername} type="text" placeholder="Username" className="mt-5" />
      <AuthTextInput value={password} onChange={setPassword} type="password" placeholder="Password" className="mt-3" />
      <Button title="Login" type="submit" className="w-100 mt-5" />
      <p className="text-center fs-10 mt-2"><a className="text-decoration-none" href="#">Forgot password?</a></p>
    </AuthLayout>
  )
}

export default Login
