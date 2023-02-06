class Profile:

    def __init__(self, mail, data):
        self.mail = mail
        self.birthdate = data['birthdate']
        self.kids = len(data['kids']) > 0
    
    def __str__(self):
        return "Profile: " + self.mail + " - " + self.birthdate + " - " + str(self.kids)

    def __repr__(self):
        return self.__str__()
