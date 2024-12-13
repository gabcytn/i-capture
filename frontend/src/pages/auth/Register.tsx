import { useState } from "react";
import { useNavigate } from "react-router";
import AuthLayout from "../../layout/AuthLayout";
import Button from "../../components/Button";
import FormInput from "../../components/FormInput";

function Register() {
  const [username, setUsername] = useState<string>("");
  const [password, setPassword] = useState<string>("");
  const [confirmPass, setConfirmPass] = useState<string>("");
  const navigate = useNavigate();
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    if (password !== confirmPass) {
      alert("Passwords do not match");
      return;
    }

    try {
      const res = await fetch(`${SERVER_URL}/register`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: username,
          password: password,
        }),
      });
      if (res.status === 409) throw new Error("Username already exists");
      if (res.status !== 201)
        throw new Error(`Error status code of ${res.status}`);

      navigate("/login");
    } catch (error: unknown) {
      if (error instanceof Error) alert(error.message);
      else console.error("Unknown error on login");
    }
  };

  return (
    <AuthLayout
      subText="Already have an account? "
      subTextAnchor="Login"
      subTextHref="/login"
      onSubmit={handleSubmit}
    >
      <FormInput
        value={username}
        onChange={(e) => {
          setUsername(e.target.value);
        }}
        type="text"
        placeholder="Username"
        className="mt-5"
      />
      <FormInput
        value={password}
        onChange={(e) => {
          setPassword(e.target.value);
        }}
        type="password"
        placeholder="Password"
        className="mt-3"
      />
      <FormInput
        value={confirmPass}
        onChange={(e) => {
          setConfirmPass(e.target.value);
        }}
        type="password"
        placeholder="Confirm Password"
        className="mt-3"
      />
      <Button
        title="Sign up"
        type="submit"
        className="w-100 mt-5 btn btn-primary"
      />
    </AuthLayout>
  );
}

export default Register;
