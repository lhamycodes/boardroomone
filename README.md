## Documentation

The postman [documentation](https://documenter.getpostman.com/view/4439932/TzzAMbuK) and the base url of the api is [https://boardroomone.lhamy.codes/api](https://boardroomone.lhamy.codes/api).

## Usage

Send a `POST` request to this [endpoint](https://boardroomone.lhamy.codes/api/dp-creator) with image field

## Sample response
```json
{
    "status": true,
    "message": "Profile Image Processed Successfully",
    "data": {
        "original_image": "https://boardroomone.lhamy.codes/storage/profile_pictures/rWK8FKwBQ28n57UnejzZz4kQpjWIkYRiszDLwNaw.jpg",
        "sirv_cropped_image": "https://penguass.sirv.com/uploaded_pictures/104_dp_1629292133.jpg?crop.type=face",
        "remove_bg_image": "https://boardroomone.lhamy.codes/storage/processed_pictures/104_dp_1629292133.jpg",
        "profile_picture": "https://boardroomone.lhamy.codes/storage/processed_pictures/104_dp_1629292133.jpg"
    }
}
```

The `data.original_image` property is the image uploaded by client, the `data.sirv_cropped_image` is the image returned from SIRV, the `data.remove_bg_image` is the image returned after background removal and the `data.profile_picture` is the final processed profile picture

## Setup
1. Clone project, cd to project directory
2. Run composer install and copy content from `.env.example` file to `.env`
3. Replace the following environment variable values in your .env file `SIRV_CLIENT_ID`, `SIRV_CLIENT_SECRET`, `REMOVEBG_API_KEY`
4. Run `php artisan serve` and copy the url generated (e.g http://127.0.0.1:8000)
5. Call the `DP Creator` endpoint via Postman or any REST Client (Web, Mobile) by visisiting `base_url/api/dp-creator`
