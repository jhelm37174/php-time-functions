module.exports = function (grunt) {
  return {
           unit: {
                dir: 'tests'
            },
            options: {
                bin: 'phpunit',
                bootstrap: 'tests/Bootstrap.php',
                colors: true,
                testdox: true
            }
  };
};
