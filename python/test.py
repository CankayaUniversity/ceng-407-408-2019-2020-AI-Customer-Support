#!/usr/bin/env python
import sys
# import json

string = ''
for word in sys.argv[1:]:
    string += word + ' '

print (string)

# import pandas as pd
# import gzip

# def parse(path):
#   g = gzip.open(path, 'rb')
#   for l in g:
#     yield eval(l)

# def getDF(path):
#   i = 0
#   df = {}
#   for d in parse(path):
#     df[i] = d
#     i += 1
#   return pd.DataFrame.from_dict(df, orient='index')

# df = getDF('python/qa_Software.json.gz')
# df.drop(["answerTime","unixTime"],axis=1,inplace=True)
# df.to_csv("data.csv")

