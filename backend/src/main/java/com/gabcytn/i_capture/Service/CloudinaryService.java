package com.gabcytn.i_capture.Service;

import com.cloudinary.Cloudinary;
import com.cloudinary.utils.ObjectUtils;
import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Repository.UserRepository;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.Map;
import java.util.Optional;

@Service
public class CloudinaryService {
    private final Cloudinary cloudinary;
    private final UserRepository userRepository;

    public CloudinaryService(Cloudinary cloudinary, UserRepository userRepository) {
        this.cloudinary = cloudinary;
        this.userRepository = userRepository;
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


    private void deleteImageInCloudinary (int id) throws IOException {
//        Optional<Item> item = itemRepository.findById(id);
//        if (item.isPresent()) {
//            final String publicID = item.get().doGetImagePublicID();
//            cloudinary.uploader().destroy(publicID, null);
//        }
    }
}
