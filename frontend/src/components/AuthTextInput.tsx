type AuthTextInputProps = {
  type: string;
  placeholder: string;
  className: string;
}
function AuthTextInput({ type, placeholder, className }: AuthTextInputProps) {
  return (
    <input type={type} placeholder={placeholder} className={className + " form-control"} />
  )
}

export default AuthTextInput
