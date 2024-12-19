import DialogBox from "../../../components/DialogBox";
import FormInput from "../../../components/FormInput";
import Button from "../../../components/Button";
import { useState } from "react";

async function handleChangeProfilePic(file: File | null) {
  if (file === null) {
    alert("File can't be null");
    return;
  }
  const serverUrl = import.meta.env.VITE_SERVER_URL;
  const formData = new FormData();
  formData.append("id", sessionStorage.getItem("id")!);
  formData.append("file", file);
  try {
    const res = await fetch(`${serverUrl}/profile-image`, {
      method: "POST",
      body: formData,
      credentials: "include",
    });
    if (res.status === 202) {
      location.reload();
      return;
    }

    throw new Error(`Error status code of ${res.status}`);
  } catch (e: unknown) {
    if (e instanceof Error) {
      console.error("Error uploading image");
      console.error(e.message);
    }
  }
}

type UpdateProfileProps = {
  isDialogOpen: boolean;
  setIsDialogOpen: (val: boolean) => void;
};

function UpdateProfile({ isDialogOpen, setIsDialogOpen }: UpdateProfileProps) {
  const [profileImage, setProfileImage] = useState<File | null>(null);
  return (
    <DialogBox title="Update Profile" isOpen={isDialogOpen}>
      <FormInput
        type="file"
        onChange={(e) => {
          if (e.target.files && e.target.files.length !== 0) {
            setProfileImage(e.target.files[0]);
          }
        }}
      />
      <Button
        className="mt-3 btn btn-primary"
        title="Submit"
        type="button"
        handleClick={() => {
          handleChangeProfilePic(profileImage);
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

export default UpdateProfile;
