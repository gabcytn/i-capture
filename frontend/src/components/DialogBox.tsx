import { CSSProperties, ReactNode } from "react";

type DialogProps = {
  isOpen: boolean;
  title: string;
  children: ReactNode;
};

function DialogBox({ isOpen, title, children }: DialogProps) {
  if (!isOpen) return null;
  return (
    <div style={backdrop}>
      <div style={mainDialog}>
        <h3 className="text-center">{title}</h3>
        {children}
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
};

const mainDialog: CSSProperties = {
  background: "white",
  width: "30vw",
  padding: "1.25rem",
  border: "none",
  borderRadius: "10px",
  boxShadow: "0px 3px 15px rgba(0, 0, 0, 0.3)",
};

export default DialogBox;
