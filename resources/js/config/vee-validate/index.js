import { defineRule, configure } from "vee-validate";

configure({
    validateOnBlur: true,
    validateOnChange: true,
    validateOnInput: true,
});

defineRule("required", (value) => {
    if (!value || !value.length) {
        return "This field is required!";
    }
    return true;
});

defineRule("min", (value, [limit]) => {
    if (value.length < limit) {
        return `The minimum length of this field is ${limit} characters!`;
    }
    return true;
});

defineRule("max", (value, [limit]) => {
    if (value.length > limit) {
        return `The maximum length of this field is ${limit} characters!`;
    }
    return true;
});

defineRule("minNumber", (value, [limit]) => {
    if (+value < limit) {
        return `The minimum value of this field is ${limit}`;
    }
    return true;
});

defineRule("maxNumber", (value, [limit]) => {
    if (+value > limit) {
        return `The maximim value of this field is ${limit}`;
    }

    return true;
});

defineRule("email", (value) => {
    const regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!regexEmail.test(value)) {
        return "Please write correct email";
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
