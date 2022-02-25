# I have a problem with Swoole and mysql

**Reproduction steps**

1. Start Swoole server with `docker-compose up` 
2. Once the containers finishes up booting, run the test script with `sh test.sh` 

test.sh simply run curl 10 times on localhost and prints the output. "success" means that the page rendered. empty means that curl didn't get a response. 

The output of of test.sh looks like this: 
```
attempt 1:
success
attempt 2:

attempt 3:
success
attempt 4:

attempt 5:

attempt 6:
success
attempt 7:

attempt 8:
success
attempt 9:

attempt 10:
success
```

The ouput of the container looks like this
```
swoole_1  | string(8) "/1 start"
swoole_1  | string(6) "/1 end"
swoole_1  | [2022-02-25 07:13:46 #631.4]	INFO	Server is shutdown now
swoole_1  | swoole: signalled
swoole_1  | 2022-02-25 07:13:46,593 INFO exited: swoole (exit status 0; expected)
swoole_1  | 2022-02-25 07:13:47,598 INFO spawned: 'swoole' with pid 649
swoole_1  | string(8) "/3 start"
swoole_1  | string(6) "/3 end"
swoole_1  | 2022-02-25 07:13:49,005 INFO success: swoole entered RUNNING state, process has stayed up for > than 1 seconds (startsecs)
swoole_1  | [2022-02-25 07:13:49 #649.4]	INFO	Server is shutdown now
swoole_1  | swoole: signalled
swoole_1  | 2022-02-25 07:13:49,021 INFO exited: swoole (exit status 0; expected)
swoole_1  | 2022-02-25 07:13:50,025 INFO spawned: 'swoole' with pid 667
swoole_1  | string(8) "/5 start"
swoole_1  | string(6) "/5 end"
swoole_1  | 2022-02-25 07:13:51,416 INFO success: swoole entered RUNNING state, process has stayed up for > than 1 seconds (startsecs)
swoole_1  | string(8) "/6 start"
swoole_1  | string(6) "/6 end"
swoole_1  | [2022-02-25 07:13:51 #667.4]	INFO	Server is shutdown now
swoole_1  | swoole: signalled
swoole_1  | 2022-02-25 07:13:51,739 INFO exited: swoole (exit status 0; expected)
swoole_1  | 2022-02-25 07:13:52,742 INFO spawned: 'swoole' with pid 685
swoole_1  | string(8) "/8 start"
swoole_1  | string(6) "/8 end"
swoole_1  | 2022-02-25 07:13:54,039 INFO success: swoole entered RUNNING state, process has stayed up for > than 1 seconds (startsecs)
swoole_1  | [2022-02-25 07:13:54 #685.4]	INFO	Server is shutdown now
swoole_1  | swoole: signalled
swoole_1  | 2022-02-25 07:13:54,054 INFO exited: swoole (exit status 0; expected)
swoole_1  | 2022-02-25 07:13:55,058 INFO spawned: 'swoole' with pid 703
swoole_1  | string(9) "/10 start"
swoole_1  | string(7) "/10 end"
swoole_1  | 2022-02-25 07:13:56,508 INFO success: swoole entered RUNNING state, process has stayed up for > than 1 seconds (startsecs)
```

**When I hit the server faster, curl works but the server reboots**

If I edit test.sh and remove the `sleep 1 ` command, then the curls succeed but there's a server shutdown happening after all commands have ran.

```
attempt 1:
success
attempt 2:
success
attempt 3:
success
attempt 4:
success
attempt 5:
success
attempt 6:
success
attempt 7:
success
attempt 8:
success
attempt 9:
success
attempt 10:
success
```

There's a reboot that happen at the end
```
swoole_1  | string(8) "/1 start"
swoole_1  | string(6) "/1 end"
swoole_1  | string(8) "/2 start"
swoole_1  | string(6) "/2 end"
swoole_1  | string(8) "/3 start"
swoole_1  | string(6) "/3 end"
swoole_1  | string(8) "/4 start"
swoole_1  | string(6) "/4 end"
swoole_1  | string(8) "/5 start"
swoole_1  | string(6) "/5 end"
swoole_1  | string(8) "/6 start"
swoole_1  | string(6) "/6 end"
swoole_1  | string(8) "/7 start"
swoole_1  | string(6) "/7 end"
swoole_1  | string(8) "/8 start"
swoole_1  | string(6) "/8 end"
swoole_1  | string(8) "/9 start"
swoole_1  | string(6) "/9 end"
swoole_1  | string(9) "/10 start"
swoole_1  | string(7) "/10 end"
swoole_1  | [2022-02-25 07:17:07 #805.4]	INFO	Server is shutdown now
swoole_1  | swoole: signalled
swoole_1  | 2022-02-25 07:17:07,971 INFO exited: swoole (exit status 0; expected)
swoole_1  | 2022-02-25 07:17:08,976 INFO spawned: 'swoole' with pid 823
swoole_1  | 2022-02-25 07:17:09,979 INFO success: swoole entered RUNNING state, process has stayed up for > than 1 seconds (startsecs)
```

**Without the mounted folder, everything works**

If I edit docker-compose.yml and comment out the volume mount on line 21: `#./mysql-data:/var/lib/mysql` 

```
attempt 1:
success
attempt 2:
success
attempt 3:
success
attempt 4:
success
attempt 5:
success
attempt 6:
success
attempt 7:
success
attempt 8:
success
attempt 9:
success
attempt 10:
success
```

there's no reboot at the end
```
swoole_1  | string(8) "/1 start"
swoole_1  | string(6) "/1 end"
swoole_1  | string(8) "/2 start"
swoole_1  | string(6) "/2 end"
swoole_1  | string(8) "/3 start"
swoole_1  | string(6) "/3 end"
swoole_1  | string(8) "/4 start"
swoole_1  | string(6) "/4 end"
swoole_1  | string(8) "/5 start"
swoole_1  | string(6) "/5 end"
swoole_1  | string(8) "/6 start"
swoole_1  | string(6) "/6 end"
swoole_1  | string(8) "/7 start"
swoole_1  | string(6) "/7 end"
swoole_1  | string(8) "/8 start"
swoole_1  | string(6) "/8 end"
swoole_1  | string(8) "/9 start"
swoole_1  | string(6) "/9 end"
swoole_1  | string(9) "/10 start"
swoole_1  | string(7) "/10 end"
```
