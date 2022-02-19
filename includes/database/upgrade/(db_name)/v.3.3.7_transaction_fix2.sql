UPDATE transactions
SET
  transactions.condition = 'ok',
  transactions.verify = 1,
  transactions.meta = CONCAT(transactions.meta, '_manual verify')
WHERE
transactions.id IN (134760,126965,126390,125785,124790,124772,124140,124145,124130,124110,123351,116848,115071,113273,112368,108152,104935,104734,98916,93652,78293,78078,74095)

