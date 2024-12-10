import AuthLayout from "../../layout/AuthLayout"
import Button from "../../components/Button"
import AuthTextInput from "../../components/AuthTextInput"

function Register() {
  return (
    <AuthLayout subText="Already have an account? " subTextAnchor="Login" subTextHref="/login">
      <AuthTextInput type="text" placeholder="Username" className="mt-5" />
      <AuthTextInput type="password" placeholder="Password" className="mt-3" />
      <Button title="Sign up" type="submit" className="w-100 mt-5" />
    </AuthLayout>
  )
}

export default Register
