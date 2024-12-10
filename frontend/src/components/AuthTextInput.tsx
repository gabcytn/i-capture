type AuthTextInputProps = {
  type: string;
  placeholder: string;
  className: string;
  value: string;
  onChange: (value: string) => void;
}
function AuthTextInput({ type, placeholder, className, value, onChange }: AuthTextInputProps) {
  return (
    <input value={value} onChange={(e) => { onChange(e.target.value) }} type={type} placeholder={placeholder} className={className + " form-control"} />
  )
}

export default AuthTextInput
