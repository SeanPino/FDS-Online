@echo on
set arg1=%1
set arg2=%2
shift
shift
cd "C:\Program Files\Ampps\www\FDS-Online\uploads\%arg1%"
fds %arg2%