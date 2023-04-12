import { configure } from "vee-validate";
import { localize } from "@vee-validate/i18n";

configure({
    generateMessage: localize({
        en: {
            names: {
                username: "Name",
                email: "Email",
            },
            messages: {
                required: "This field is required",
                email: "Please write correct email",
                min: "The minimum value of this field is 0:{min} characters",
                max: "The maximum length of this field is 0:{max} characters",
                minNumber: "`The minimum value of this field is 0:{min}",
                maxNumber: "The maximum value of this field is 0:{max}",
                minWordsThree: "This field needs at least 3 words",
                phone: "Incorrect phone number format",
                confirmed: "Passwords doesn't match",
                upperAndLower: "The field must contain at least one uppercase and one lowercase character"
            },
        },
        hu: {
            names: {
                username: "Username HU",
                email: "Email HU",
            },
            messages: {
                required: "This field is required HU",
                email: "Please write correct email HU",
                min: "The minimum value of this field is 0:{min} characters HU",
                max: "The maximum length of this field is 0:{max} characters HU",
                minNumber: "`The minimum value of this field is 0:{min} HU",
                maxNumber: "The maximum value of this field is 0:{max} HU",
                minWordsThree: "This field needs at least 3 words HU",
                phone: "Incorrect phone number format HU",
                confirmed: "Passwords doesn't match HU",
                upperAndLower: "The field must contain at least one uppercase and one lowercase character HU"
            },
        },
    }),
});
