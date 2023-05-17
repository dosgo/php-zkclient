<?php
	const	opNotify          = 0;
	const	opCreate          = 1;
	const	opDelete          = 2;
	const	opExists          = 3;
	const	opGetData         = 4;
	const	opSetData         = 5;
	const	opGetAcl          = 6;
	const	opSetAcl          = 7;
	const	opGetChildren     = 8;
	const	opSync            = 9;
	const	opPing            = 11;
	const	opGetChildren2    = 12;
	const	opCheck           = 13;
	const	opMulti           = 14;
	const	opReconfig        = 16;
	const	opCreateContainer = 19;
	const	opCreateTTL       = 21;
	const	opClose           = -11;
	const	opSetAuth         = 100;
	const	opSetWatches      = 101;
	const	opError           = -1;
		// Not in protocol, used internally
	const	opWatcherEvent = -2;

	const  PERM_READ = 1;
	const  PERM_WRITE = 2;
	const  PERM_CREATE = 4;
	const  PERM_DELETE = 8;
	const  PERM_ADMIN = 16;
	const  PERM_ALL = 31;
