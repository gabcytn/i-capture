type ButtonProps = {
  title: string;
  type: "button" | "reset" | "submit";
  className: string;
  handleClick?: () => void;
};
function Button({ title, type, className, handleClick }: ButtonProps) {
  return (
    <button className={className} type={type} onClick={handleClick}>
      {title}
    </button>
  );
}

export default Button;
