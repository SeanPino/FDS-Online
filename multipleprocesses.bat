@echo on
set arg1=%1
set arg2=%2
shift
shift
cd c:\users\sean\documents\pyro\uploads\%arg1%
mpiexec -genv OMP_NUM_THREADS 2 fds %arg2%
