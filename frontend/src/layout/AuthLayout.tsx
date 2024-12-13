import { ReactNode } from "react";

type AuthLayoutProps = {
  children: ReactNode;
  subText: string;
  subTextHref: string;
  subTextAnchor: string;
  onSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
};

function AuthLayout({
  children,
  subText,
  subTextHref,
  subTextAnchor,
  onSubmit,
}: AuthLayoutProps) {
  return (
    <div className="container mt-3" style={{ maxWidth: "750px " }}>
      <div className="row">
        <div className="col-6">
          <img src="/auth-img.png" alt="Auth image" />
        </div>
        <div className="col-6">
          <form style={form} onSubmit={onSubmit}>
            <h3 style={heading} className="mb-5 text-center">
              iCapture
            </h3>
            {children}
          </form>

          <div
            style={subTextsStyle}
            className="d-flex justify-content-center align-items-center p-3 mt-3"
          >
            <p>
              {subText}
              <a href={subTextHref}>{subTextAnchor}</a>{" "}
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}

const subTextsStyle = {
  border: "1px solid #CCC",
};

const heading = {
  fontFamily: "Lobster Two",
};

const form = {
  height: "400px",
  border: "1px solid #CCC",
  marginTop: "2.5rem",
  padding: "2rem 1.5rem",
};

export default AuthLayout;
