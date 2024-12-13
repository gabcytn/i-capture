type FormInputProps = {
  type: string;
  placeholder?: string;
  className?: string;
  value?: string;
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
};
function FormInput({
  type,
  placeholder,
  className,
  value,
  onChange,
}: FormInputProps) {
  return (
    <input
      value={value}
      onChange={onChange}
      type={type}
      placeholder={placeholder}
      className={className + " form-control"}
    />
  );
}

export default FormInput;
