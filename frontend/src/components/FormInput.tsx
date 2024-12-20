type FormInputProps = {
  type: string;
  placeholder?: string;
  className?: string;
  value?: string;
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
  name?: string;
};
function FormInput({
  type,
  placeholder,
  className,
  value,
  onChange,
  name,
}: FormInputProps) {
  return (
    <input
      value={value}
      onChange={onChange}
      type={type}
      placeholder={placeholder}
      className={className + " form-control"}
      required
      name={name}
    />
  );
}

export default FormInput;
