import { defineRule, configure } from "vee-validate";

configure({
    validateOnBlur: true,
    validateOnChange: true,
    validateOnInput: true,
});

defineRule("email", (value) => {
    const regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!regexEmail.test(value)) {
        return;
    }
    return true;
});

defineRule("min-words-3", (value) => {
    const regexMinWords = /^([a-z0-9]*[a-z]){3}[a-z0-9]*$/i;
    if (!regexMinWords.test(value)) {
        return;
    }
    return true;
});

defineRule("phone", (value) => {
    const regexPhoneNumber =
        /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/;
    if (!regexPhoneNumber.test(value)) {
        return;
    }
    return true;
});
