// The N is the number of values within a list of numbers.
function findN(array) {
  return array.length;
}

function findSum(array) {
  return array.reduce((acc, val) => acc + val, 0);
}

function findMean(array) {
  return findSum(array) / findN(array);
}

// The median is the middle value (odd list of numbers) or the mid-point of the middle two (even list of numbers) in a sorted list of numbers.
function findMedian(array) {
  const sortedArray = array.slice().sort((a, b) => a - b);
  const midIndex = Math.floor(sortedArray.length / 2);
  if (sortedArray.length % 2 === 0) {
    return (sortedArray[midIndex - 1] + sortedArray[midIndex]) / 2;
  } else {
    return sortedArray[midIndex];
  }
}

// The mode is the value that occurs the most frequently in a list of numbers.
function findMode(array) {
  const frequencyMap = {};
  let maxFreq = 0;
  let modes = [];
  array.forEach((item) => {
    if (!frequencyMap[item]) frequencyMap[item] = 0;
    frequencyMap[item]++;
    if (frequencyMap[item] > maxFreq) {
      maxFreq = frequencyMap[item];
      modes = [item];
    } else if (frequencyMap[item] === maxFreq) {
      modes.push(item);
    }
  });
  if (modes.length === array.length) modes = [];
  return modes.length === 1 ? modes[0] : modes;
}

// The maximum is the highest value in the array.
function findMax(array) {
  return Math.max(...array);
}

// The minimum is the lowest value in the array.
function findMin(array) {
  return Math.min(...array);
}

// The range is the difference between the maximum and minimum values in the array.
function findRange(array) {
  return findMax(array) - findMin(array);
}

// The variance is the average of the squared differences from the Mean.
function findVariance(array) {
  const mean = findMean(array);
  return (
    array.reduce((acc, val) => acc + Math.pow(val - mean, 2), 0) /
    (findN(array) - 1)
  );
}

// The standard deviation is the square root of the variance.
function findStandardDeviation(array) {
  return Math.sqrt(findVariance(array));
}
