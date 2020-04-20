old_reply = ''
new_answer = ''
flag = 1
for word in sys.argv[1:]:
    if(word == "/"):
        flag=0
        continue
    if(flag == 1):
        old_reply += word + ' '
    elif(flag == 0):
        question += word + ' '

data = pd.read_csv("data.csv")

data[data.answer == old_reply].answer = old_reply