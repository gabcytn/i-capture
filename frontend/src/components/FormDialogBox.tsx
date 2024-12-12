import { CSSProperties } from "react";

type DialogProps = {
  onClose: () => void;
  isOpen: boolean;
  title: string;
  inputType: string;
  placeholder?: string;
}
function DialogBox({ onClose, isOpen, title, inputType, placeholder }: DialogProps) {
  if (!isOpen) return null;
  return (
    <div
      style={backdrop}
    >
      <div
        style={mainDialog}
      >
        <h3 className="text-center">{title}</h3>
        {placeholder ? <input type={inputType} className="form-control" placeholder={placeholder} /> :
          <input type={inputType} className="form-control" />}
        <div className="d-flex mt-3">
          <button className="btn btn-primary me-2">Submit</button>
          <button onClick={onClose} className="btn btn-danger">Close</button>
        </div>
      </div>
    </div>
  );
}

const backdrop: CSSProperties = {
  position: "fixed",
  top: "0",
  left: "0",
  width: "100vw",
  height: "100vh",
  background: "rgba(0, 0, 0, 0.5)",
  display: "flex",
  alignItems: "center",
  justifyContent: "center",
}

const mainDialog: CSSProperties = {
  background: "white",
  width: "30vw",
  padding: "1.25rem",
  border: "none",
  borderRadius: "10px",
  boxShadow: "0px 3px 15px rgba(0, 0, 0, 0.3)"
}

export default DialogBox
