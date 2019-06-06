UPDATE transactions SET transactions.wayopt = NULL, transactions.totalcount = null WHERE transactions.id < 20269 AND (transactions.wayopt IS NOT NULL OR transactions.totalcount IS NOT NULL);
