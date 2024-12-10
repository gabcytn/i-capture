import AuthLayout from "../../layout/AuthLayout"
import Button from "../../components/Button"
import AuthTextInput from "../../components/AuthTextInput"

function Login() {
  return (
    <AuthLayout subText="Don't have an account? " subTextAnchor="Sign up" subTextHref="/register">
      <AuthTextInput type="text" placeholder="Username" className="mt-5" />
      <AuthTextInput type="password" placeholder="Password" className="mt-3" />
      <Button title="Login" type="submit" className="w-100 mt-5" />
      <p className="text-center fs-10 mt-2"><a className="text-decoration-none" href="#">Forgot password?</a></p>
    </AuthLayout>
  )
}

export default Login
