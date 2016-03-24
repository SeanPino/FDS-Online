@echo on
set arg1=%1
set arg2=%2
shift
shift
cd c:\xampp\htdocs\uploads\%arg1%
fds %arg2%
