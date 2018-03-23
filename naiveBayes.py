#!/usr/bin/python

import csv
import random
import math
import MySQLdb

def loadCsv(filename):
	lines = csv.reader(open(filename, "rb"))
	dataset = list(lines)
	for i in range(len(dataset)):
		dataset[i] = [float(x) for x in dataset[i]]
	return dataset

def splitDataset(dataset, splitRatio):
	trainSize = int(len(dataset) * splitRatio)
	trainSet = []
	copy = list(dataset)
	while len(trainSet) < trainSize:
		index = random.randrange(len(copy))
		trainSet.append(copy.pop(index))
	return [trainSet, copy]

def separateByClass(dataset):
	separated = {}
	for i in range(len(dataset)):
		vector = dataset[i]
		if (vector[-1] not in separated):
			separated[vector[-1]] = []
		separated[vector[-1]].append(vector)
	return separated

def mean(numbers):
	return sum(numbers)/float(len(numbers))
 
def stdev(numbers):
	avg = mean(numbers)
	variance = sum([pow(x-avg,2) for x in numbers])/float(len(numbers)-1)
	return math.sqrt(variance)

def summarize(dataset):
	summaries = [(mean(attribute), stdev(attribute)) for attribute in zip(*dataset)]
	del summaries[-1]
	return summaries

def summarizeByClass(dataset):
	separated = separateByClass(dataset)
	summaries = {}
	for classValue, instances in separated.iteritems():
		summaries[classValue] = summarize(instances)
	return summaries

def calculateProbability(x, mean, stdev):
	exponent = math.exp(-(math.pow(x-mean,2)/(2*math.pow(stdev,2))))
	return (1 / (math.sqrt(2*math.pi) * stdev)) * exponent

def calculateClassProbabilities(summaries, inputVector):
	probabilities = {}
	for classValue, classSummaries in summaries.iteritems():
		probabilities[classValue] = 1
		for i in range(len(classSummaries)):
			mean, stdev = classSummaries[i]
			x = inputVector[i]
			probabilities[classValue] *= calculateProbability(x, mean, stdev)
	return probabilities

def predict(summaries, inputVector):
	probabilities = calculateClassProbabilities(summaries, inputVector)
	bestLabel, bestProb = None, -1
	for classValue, probability in probabilities.iteritems():
		if bestLabel is None or probability > bestProb:
			bestProb = probability
			bestLabel = classValue
	return bestLabel

def getPredictions(summaries, testSet):
	predictions = []
	for i in range(len(testSet)):
		result = predict(summaries, testSet[i])
		predictions.append(result)
	return predictions

def getAccuracy(testSet, predictions):
	correct = 0
	for x in range(len(testSet)):
		if testSet[x][-1] == predictions[x]:
			correct += 1
	return (correct/float(len(testSet))) * 100.0


def main():

	# Open database connection
	db = MySQLdb.connect("localhost","sye19","password","admin" )

	# prepare a cursor object using cursor() method
	cursor = db.cursor()

	filename = 'Input.csv'
	writer = 'Output.csv'
	#splitRatio = 0.67
	dataset = loadCsv(filename)
	#trainingSet, testSet = splitDataset(dataset, splitRatio)
	#print('Split {0} rows into train={1} and test={2} rows').format(len(dataset), len(trainingSet), len(testSet))

	# prepare model
	summaries = summarizeByClass(dataset)

	# test model
	predictions = getPredictions(summaries, dataset)
	accuracy = getAccuracy(dataset, predictions)

	with open(writer,"w") as output:
		writer1 = csv.writer(output,lineterminator='\n')
		for val in predictions:
			writer1.writerow([val])

	# Prepare SQL query to INSERT a record into the database.
	sql = "ALTER TABLE Details DROP COLUMN CLASS"
	sql0 = "CREATE TABLE IF NOT EXISTS CLASSES (Class INT)"
	sql1 = "INSERT INTO CLASSES VALUES(%s)"
	sql2 = "ALTER TABLE CLASSES ADD COLUMN Id INT PRIMARY KEY AUTO_INCREMENT FIRST"
	sql3 = "ALTER TABLE Details ADD COLUMN CLASS INT"
	sql4 = "UPDATE Details B INNER JOIN CLASSES A ON B.Id = A.Id SET B.Class = A.Class"
	sql5 = "DROP TABLE CLASSES"
	try:
	   # Execute the SQL command
	   cursor.execute(sql)
	   cursor.execute(sql0)
	   csv_data = csv.reader(file(writer))
	   for row in csv_data:
	   	cursor.execute(sql1,row)
	   cursor.execute(sql2)
	   cursor.execute(sql3)
	   cursor.execute(sql4)
	   cursor.execute(sql5)
	   #Commit your changes in the database
	   db.commit()

	except:
	   # Rollback in case there is any error
	   print "cannot"
	   db.rollback()

	# disconnect from server
	db.close()

	print('Accuracy: {0}%').format(accuracy)
 
main()
