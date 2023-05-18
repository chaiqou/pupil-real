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
        minNumber: "The minimum value of this field is 0:{min}",
        maxNumber: "The maximum value of this field is 0:{max}",
        minWordsThree: "This field needs at least 3 characters",
        phone: "Incorrect phone number format",
        confirmed: "Passwords doesn't match",
        upperAndLower:
          "The field must contain at least one uppercase and one lowercase character",
      },
    },
    hu: {
      names: {
        username: "Felhasználónév",
        email: "Email",
      },
      messages: {
        required: "Ezt a mezőt kötelező kitölteni",
        email: "Adjon meg egy érvényes email címet",
        min: "A mező minimum hossza 0:{min} karakter",
        max: "A mező maximum hossza 0:{max} karakter",
        minNumber: "A mező minimum értéke 0:{min}",
        maxNumber: "A mező maximum értéke 0:{max}",
        minWordsThree: "Ennek a mezőnek legalább 3 szóra van szüksége",
        phone: "Adjon meg egy érvényes telefonszámot",
        confirmed: "A jelszavak nem egyeznek",
        upperAndLower: "A mezőnek tartalmaznia kell legalább egy nagy és egy kisbetűt",
      },
    },
  }),
});
