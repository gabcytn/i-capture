type ButtonProps = {
  title: string;
  type: "button" | "reset" | "submit";
  className: string;
}
function Button({ title, type, className }: ButtonProps) {
  return (
    <button className={className + " btn btn-primary"} type={type}>{title}</button>
  )
}

export default Button
