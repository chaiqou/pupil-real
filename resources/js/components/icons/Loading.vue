<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 208.626 221.04792" class="p-1">
        <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#0061F2" />
                <stop offset="100%" stop-color="#6900C7" />
            </linearGradient>
        </defs>
        <path
            d="M0,87.083H59.80587c28.8386,0,50.12881,18.58037,50.12881,44.90167s-21.29021,44.90167-50.12881,44.90167H28.45v43.16161H0Zm56.71089,63.67459c14.127,0,23.804-7.35232,23.804-18.77292s-9.677-18.77292-23.804-18.77292H28.45v37.54584Z"
            transform="translate(0.5 0.5)"
            style="fill: #000; stroke: none; stroke-miterlimit: 10"
        />
        <polygon
            points="208.126 183.149 128.511 183.149 128.511 158.053 183.03 158.053 183.03 25.596 25.62 25.596 25.62 60.873 0.525 60.873 0.525 0.5 208.126 0.5 208.126 183.149"
            stroke="url(#gradient)"
            style="
                fill: none;
                stroke-miterlimit: 10;
                animation: dash 1.3s infinite linear;
                stroke-dasharray: 500;
                stroke-dashoffset: 1000;
                stroke-width: 3;
            "
        />
    </svg>
</template>

<style>
@keyframes dash {
    from {
        stroke-dashoffset: 1000;
    }

    to {
        stroke-dashoffset: 0;
    }
}
</style>
