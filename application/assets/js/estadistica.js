function percentile(sorted_arr, p) {
if (sorted_arr.length === 0) return 0;
if (typeof p !== 'number') throw new TypeError('p must be a number');
if (p <= 0) return sorted_arr[0];
if (p >= 1) return sorted_arr[sorted_arr.length - 1];

// Para hacer mas rapido voy a tener el array pre-ordenado
//arr.sort(function (a, b) { return a - b; });
var index = (sorted_arr.length - 1) * p
    lower = Math.floor(index),
    upper = lower + 1,
    weight = index % 1;

if (upper >= sorted_arr.length) return sorted_arr[lower];
return sorted_arr[lower] * (1 - weight) + sorted_arr[upper] * weight;
}