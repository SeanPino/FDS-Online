@echo on
set arg1=%1
set arg2=%2
set arg3=%3
shift
shift
cd c:\users\sean\documents\pyro\uploads\%arg1%
mpiexec -np %arg3% fds_mpi_executable %arg2%
