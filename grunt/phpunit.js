module.exports = function (grunt) {
  return {
           unit: {
                dir: 'tests'
            },
            options: {
                bin: 'phpunit',
                bootstrap: 'tests/bootstrap.php',
                colors: true,
                testdox: true
            }
  };
};
