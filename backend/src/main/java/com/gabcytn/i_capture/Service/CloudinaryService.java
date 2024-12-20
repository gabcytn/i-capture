package com.gabcytn.i_capture.Service;

import com.cloudinary.Cloudinary;
import com.cloudinary.utils.ObjectUtils;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.Map;

@Service
public class CloudinaryService {
    private final Cloudinary cloudinary;

    public CloudinaryService(Cloudinary cloudinary) {
        this.cloudinary = cloudinary;
    }

    public String[] uploadImageToCloudinary (MultipartFile image) {
        final Map uploadParams = ObjectUtils.asMap(
                "use_filename", false,
                "unique_filename", true,
                "overwrite", true
        );
        try {
            final Map uploadReturnValue = cloudinary.uploader().upload(image.getBytes(), uploadParams);
            final String imageURL = uploadReturnValue.get("secure_url").toString();
            final String publicID = uploadReturnValue.get("public_id").toString();
            return new String[]{imageURL, publicID};
        } catch (IOException e) {
            System.err.println("Error: " + e.getMessage());
            return new String[0];
        }
    }

    public void deleteImageInCloudinary (String publicId) throws IOException {
        cloudinary.uploader().destroy(publicId, null);
    }
}
