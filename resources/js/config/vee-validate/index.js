import { defineRule } from "vee-validate";
import { required, min, max, numeric } from "@vee-validate/rules";
import { configure } from "vee-validate";

configure({
    validateOnBlur: true,
    validateOnChange: true,
    validateOnInput: true,
});

defineRule("required", required);
defineRule("min", min);
defineRule("max", max);
defineRule("numeric", numeric);
