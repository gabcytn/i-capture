import DialogBox from "../../../components/DialogBox";
import FormInput from "../../../components/FormInput";
import Button from "../../../components/Button";
import { useState } from "react";

async function handlePasswordChange(
  oldPass: string,
  newPass: string,
  setDialogOpen: (val: boolean) => void,
) {
  if (oldPass === "" || newPass === "") {
    alert("Fields can't be blank");
    return;
  }
  try {
    const serverUrl = import.meta.env.VITE_SERVER_URL;
    const res = await fetch(`${serverUrl}/change-password`, {
      method: "PUT",
      body: JSON.stringify({
        id: sessionStorage.getItem("id"),
        oldPassword: oldPass,
        newPassword: newPass,
      }),
      credentials: "include",
      headers: {
        "Content-Type": "application/json",
      },
    });
    switch (res.status) {
      case 400:
        alert("Incorrect password");
        return;
      case 202:
        setDialogOpen(false);
        alert("Successfully changed password");
        return;
      case 403:
        alert("Your session has expired...Logging you out");
        sessionStorage.clear();
        location.reload();
        return;
      default:
        throw new Error(`Error status code of ${res.status}`);
    }
  } catch (e: unknown) {
    if (e instanceof Error) {
      alert("Error updating password. Please try again.");
      console.error(e.message);
    }
  }
}

type UpdatePasswordProps = {
  isDialogOpen: boolean;
  setIsDialogOpen: (val: boolean) => void;
};

function UpdatePassword({
  isDialogOpen,
  setIsDialogOpen,
}: UpdatePasswordProps) {
  const [oldPasswordValue, setOldPasswordValue] = useState<string>("");
  const [newPasswordValue, setNewPasswordValue] = useState<string>("");
  return (
    <DialogBox title="Update Password" isOpen={isDialogOpen}>
      <FormInput
        type="password"
        onChange={(e) => {
          setOldPasswordValue(e.target.value);
        }}
        value={oldPasswordValue}
        className="mt-3"
        placeholder="Old password"
      />
      <FormInput
        type="password"
        onChange={(e) => {
          setNewPasswordValue(e.target.value);
        }}
        value={newPasswordValue}
        className="mt-2"
        placeholder="New password"
      />
      <Button
        className="mt-3 btn btn-primary"
        title="Submit"
        type="button"
        handleClick={() => {
          handlePasswordChange(
            oldPasswordValue,
            newPasswordValue,
            setIsDialogOpen,
          );
          setOldPasswordValue("");
          setNewPasswordValue("");
        }}
      />
      <Button
        className="mt-3 ms-2 btn btn-danger"
        title="Close"
        type="button"
        handleClick={() => {
          setIsDialogOpen(false);
        }}
      />
    </DialogBox>
  );
}

export default UpdatePassword;
