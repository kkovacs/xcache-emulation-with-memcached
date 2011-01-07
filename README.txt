Recently we had to migrate a project from a server that had XCache installed (like all our servers) to a very different environment (more precisely, into the Rackspace Cloud Sites). The problem was, of course, that not only Sites doesn't have XCache installed, it would also be pointless, since one can not be sure which of the application servers will process a certain request. Also, invalidating the cache across all servers would be a nightmare.

So, I coded up a quick solution to use the same PHP software without any modification, but using a memcached server. I figured it may be useful for other people out there, so here it is.

