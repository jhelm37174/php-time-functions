module.exports = function (grunt) {
  return {
           unit: {
                dir: 'tests'
            },
            options: {
                bin: 'phpunit',
                bootstrap: 'src/getworkinghours.php',
                colors: true,
                testdox: true
            }
  };
};
